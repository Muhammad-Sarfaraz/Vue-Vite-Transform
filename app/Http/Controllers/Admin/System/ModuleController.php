<?php

namespace App\Http\Controllers\Admin\System;

use App\Helpers\Module;
use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ModuleController extends Controller {
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Request $request ) {
        Session::put( 'model', $request->model_name );
        $model = Session::get( 'model' );

        if ( $request->format() == 'html' ) {
            return view( 'layouts.admin_app' );
        }
        if ( $request->isMethod( 'get' ) ) {
            return Module::folderPath( $model ?? 'Test' );
        }
        if ( $request->isMethod( 'post' ) ) {
            return $this->store( $request );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkModel( Request $request ) {
        return Module::check( $request );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        $model      = $request->model_name ?? "";
        $only_model = $request->only_model ?? "";

        if ( $this->validateCheck( $request ) ) {
            $ex = str_split( $model );
            if ( $ex[0] == ucfirst( $ex[0] ) ) {
                if ( Module::createFile( $model, $only_model ) ) {

                    // Database create
                    $this->databaseCreate( $request->databases, lcfirst( $model ) );

                    // Form create
                    if ( empty( $only_model ) ) {
                        $this->createForm( $request->databases, lcfirst( $model ) );
                    }

                    return response()->json( ['message' => 'Module Create Successfully'], 200 );
                } else {
                    return response()->json( ['error' => 'Something went wrong, but Some file are crated, please check'], 200 );
                }
            } else {
                return response()->json( ['warning' => 'First Letter must be capital'], 200 );
            }
        }
    }

    /**
     * Create Database
     *
     * @return \Illuminate\Http\Response
     */
    public function databaseCreate( $fields, $table_name, $timestamps = true ) {
        $snake      = Str::snake( $table_name, '_' );
        $table_name = Str::plural( $snake, 2 );

        Schema::create( $table_name, function ( Blueprint $table ) use ( $fields, $timestamps ) {
            if ( count( $fields ) > 0 ) {
                $cnt = 0;
                foreach ( $fields as $field ) {
                    if ( in_array( $field['type'], ['integer', 'bigInteger', 'tinyInteger'] ) ) {
                        $table->{$field['type']}( $field['field_name'], false, false )->length( $field['length'] );

                    } else if ( $field['type'] == 'enum' ) {
                        $values = explode( ',', $field['length'] );
                        $table->{$field['type']}( $field['field_name'], $values );

                    } else if ( $field['length'] > 0 ) {
                        $table->{$field['type']}( $field['field_name'] )->length( $field['length'] );

                    } else {
                        $table->{$field['type']}( $field['field_name'] );
                    }
                    if ( $field['required'] == 0 ) {
                        $table->getColumns()[$cnt]->nullable();
                    }
                    // if ( $field['unsigned'] == 1 ) {
                    //     $table->getColumns()[$cnt]->unsigned();
                    // }
                    // if ( $field['default'] == 1 ) {
                    //     $table->getColumns()[$cnt]->default( $field['default_value'] );
                    // }
                    if ( strlen( $field['index'] ) > 0 ) {
                        switch ( $field['index'] ) {
                        case 'unique':
                            $table->getColumns()[$cnt]->unique();
                            break;
                        case 'index':
                            $table->getColumns()[$cnt]->index();
                            break;
                        case 'primary':
                            $table->getColumns()[$cnt]->primary();
                            break;
                        }
                    }
                    $cnt++;
                }
            }
            if ( $timestamps ) {
                $table->timestamp( 'created_at' )->default( DB::raw( 'CURRENT_TIMESTAMP' ) );
                $table->timestamp( 'updated_at' )->useCurrent()->useCurrentOnUpdate();
            }
        } );

        return "Table Created";
    }

    /**
     * Create Form
     *
     * @return \Illuminate\Http\Response
     */
    public function createForm( $fields, $model ) {
        $file = base_path( "resources/js/views/admin/$model/create.vue" );

        $myfile = fopen( $file, "w" ) or die( "Unable to open file!" );

        $params        = 'this.$route.params.id';
        $getUrl        = '${this.model}/${this.$route.params.id}';
        $toast         = '$toast';
        $validate      = '$validate';
        $postData      = "this.data";
        $inputs        = "";
        $components    = "";
        $textArea      = "";
        $formForImage  = "";
        $imageProvide  = "";
        $uploadImage   = "";
        $imageData     = "";
        $imageField    = "";
        $validateRules = "";

        foreach ( $fields ?? [] as $key => $field ) {

            $validateSelect = "";
            $req            = $field['required'] ? 'true' : 'false';
            $fieldTitle     = ucfirst( $field['field_name'] );
            $fieldName      = "data.{$field['field_name']}";

            if ( !empty( $field['input_type'] ) ) {
                if ( $key != 0 ) {
                    $inputs .= "\t\t\t\t";
                    $validateRules .= "\t\t";
                }
                if ( $field['input_type'] == 'text' ) {
                    $inputs .= "<Input v-model='{$fieldName}' field='{$fieldName}' title='{$fieldTitle}' :req='{$req}' />\n";

                } else if ( $field['input_type'] == 'select' ) {
                    $validateSelect = $field['required'] == 1 ? "<span v-if=\"validation.hasError('data.role_id')\" class='input-message danger'>{{ validation.firstError('{$fieldName}') }} </span>" : '';

                    $inputs .= "<v-select-container title='{$fieldTitle}'> <v-select v-model='{$fieldName}' label='name' :reduce='(obj) => obj.id' :options='[]' placeholder='--Select One--' :closeOnSelect='true'></v-select></v-select-container> $validateSelect\n";

                } else if ( $field['input_type'] == 'radio' ) {
                    $inputs .= "<Radio v-model='{$fieldName}' field='{$fieldName}' title='{$fieldTitle}' :list=\"[{ value: 'active', title: 'Active' },{ value: 'deactive', title: 'Deactive' }]\" :req='{$req}' col='3'/>\n";

                } else if ( $field['input_type'] == 'checkbox' ) {
                    $inputs .= "<Checkbox v-model='{$fieldName}' field='{$fieldName}' title='{$fieldTitle}' :list=\"[{ value: 'active', title: 'Active' },{ value: 'deactive', title: 'Deactive' }]\" :req='{$req}' col='3'/>\n";

                } else if ( $field['input_type'] == 'date' ) {
                    $inputs .= "<date-picker id='{$fieldName}-date'  v-model='{$fieldName}' title='{$fieldTitle}' placeholder='{$fieldTitle}' col='2' ></date-picker>\n";

                } else if ( $field['input_type'] == 'file' ) {
                    $formForImage = "var form = document.getElementById('form'); var formData = new FormData(form);";
                    $postData     = 'formData';
                    $uploadImage  = 'true';
                    $imageField   = "{$field['field_name']}:''";
                    $imageData    = "image:{}";
                    $imageProvide = "data: () => this.data, image: this.image";
                    $inputs .= "<File title='{$fieldTitle}' field='{$fieldName}' mime='img' fileClassName='{$fieldName}' />\n";

                } else if ( $field['input_type'] == 'textarea' ) {
                    $components = "components: { Editor },";
                    $textArea   = "import Editor from '../../../components/Form/CKEditor';";
                    $inputs .= "<div class='col-12 mb-3'> <label class='form-label'>$fieldTitle</label> <div class='col-12'> <editor v-model='{$fieldName}' /></div></div>";
                }

                // Required
                if ( !empty( $field['required'] ) ) {
                    $validateRules .= "'{$fieldName}': function (value = null) {
      return Validator.value(value).required('$fieldTitle is required');
    },\n";
                }
            }
        }

        $txt = "<template>
  <create-form @onSubmit='submit'>
    <div class='row align-items-center'>
        $inputs
    </div>
    <Button title='Submit' process='' />
  </create-form>
</template>

<script>
$textArea

// define model name
const model = '{$model}';

export default {
  $components
  data() {
    return {
      model: model,
      data: {{$imageField}},
      $imageData
    };
  },

  provide() {
    return {
      validate: this.validation,
      $imageProvide
    };
  },
  methods: {
    submit: function (e) {
      this.$validate().then((res) => {
        const error = this.validation.countErrors();
        // If there is an error
        if (error > 0) {
          console.log(this.validation.allErrors());
          this.$toast(
            'You need to fill ' + error + ' more empty mandatory fields',
            'warning'
          );
          return false;
        }

        // If there is no error
        if (res) {
          $formForImage

          if (this.data.id) {
            this.update(this.model, $postData, this.data.id,$uploadImage);
          } else {
            this.store(this.model, $postData);
          }
        }
      });
    },
  },
  created() {
    if ($params) {
      this.setBreadcrumbs(this.model, 'edit');
      this.get_data(`$getUrl`);
    } else {
      this.setBreadcrumbs(this.model, 'create');
    }
  },

 // validation rule for form
  validators: {
    $validateRules
  },
}

</script>";

        fwrite( $myfile, $txt );
        fclose( $myfile );

        return "Form Created";
    }

    /*--------------------------------------------
     * VALIDATION
     *-------------------------------------------*/
    public function validateCheck( $request ) {
        return $request->validate( [
            'model_name' => 'required|alpha|max:255|regex:/^\S*$/u',
        ] );
    }
}
