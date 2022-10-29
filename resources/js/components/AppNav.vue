<template>
  <div class="top-header">
    <div class="row">
      <div class="col-lg-6 left-info-col align-self-center">
        <div class="left-info d-flex">
          <div class="mobile-control-bar d-block d-lg-none">
            <i class="fas fa-bars"></i>
          </div>
          <div class="control-bar d-none d-lg-block">
            <i class="fas fa-bars"></i>
          </div>
          <div class="expand">
            <i class="fas fa-arrows-alt"></i>
          </div>
          <div class="form">
            <form action="#" method="post">
              <div class="input-groups position-relative">
                <input type="text" placeholder="Search..." />
                <button
                  type="submit"
                  class="search position-absolute bg-transparent border-0"
                >
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-6 right-info-col">
        <div
          class="
            right-info
            header-right-info
            text-end
            d-flex
            justify-content-end
            align-items-center
          "
        >
          <div class="notification dropdown">
            <div
              class="notifi-icon dropdown-toggle"
              id="dropdownMenuButton1"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <i class="far fa-bell bell"></i>
              <sup>3</sup>
            </div>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <div class="top d-flex justify-content-between">
                <h4>Notification</h4>
                <span>Clear All</span>
              </div>
              <div class="middle">
                <div class="msg-box d-flex">
                  <div class="icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                  </div>
                  <div class="text">
                    <p>Caleb Flakelar commented on Admin</p>
                    <span>2 minutes ago</span>
                  </div>
                </div>
                <div class="msg-box d-flex">
                  <div class="icon icon-2">
                    <i class="fas fa-user-plus"></i>
                  </div>
                  <div class="text">
                    <p>Caleb Flakelar commented on Admin</p>
                    <span>2 minutes ago</span>
                  </div>
                </div>
                <div class="msg-box d-flex">
                  <div class="icon icon-3">
                    <i class="fas fa-heart"></i>
                  </div>
                  <div class="text">
                    <p>Caleb Flakelar commented on Admin</p>
                    <span>2 minutes ago</span>
                  </div>
                </div>
                <div class="msg-box d-flex">
                  <div class="icon icon-4">
                    <i class="fas fa-heart"></i>
                  </div>
                  <div class="text">
                    <p>Caleb Flakelar commented on Admin</p>
                    <span>2 minutes ago</span>
                  </div>
                </div>
                <div class="msg-box d-flex">
                  <div class="icon icon-5">
                    <i class="fas fa-heart"></i>
                  </div>
                  <div class="text">
                    <p>Caleb Flakelar commented on Admin</p>
                    <span>2 minutes ago</span>
                  </div>
                </div>
                <div class="msg-box d-flex">
                  <div class="icon icon-6">
                    <i class="fas fa-heart"></i>
                  </div>
                  <div class="text">
                    <p>Caleb Flakelar commented on Admin</p>
                    <span>2 minutes ago</span>
                  </div>
                </div>
              </div>
              <div class="btm text-center">
                <a href="#"
                  >Show All Notification <i class="fas fa-chevron-down"></i
                ></a>
              </div>
            </ul>
          </div>
          <div class="messages dropdown">
            <div
              class="notifi-mess dropdown-toggle"
              id="dropdownMenuButton1"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <i class="far fa-comment-alt bell mess"></i>
              <sup>9</sup>
            </div>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <div class="top d-flex justify-content-between">
                <h4>MESSAGES</h4>
                <span>Clear All</span>
              </div>
              <div class="middle">
                <div class="msg-box d-flex">
                  <div class="img">
                    <img :src="`${asset}profile.jpg`" alt="profile" />
                  </div>
                  <div class="text">
                    <h5>
                      Donna Seay
                      <span>2 minutes ago</span>
                    </h5>
                    <p>
                      A wonderful serenity has taken possession of my entire
                      soul, like these sweet mornings of spring.
                    </p>
                  </div>
                </div>
                <div class="msg-box d-flex">
                  <div class="img">
                    <img :src="`${asset}profile.jpg`" alt="profile" />
                  </div>
                  <div class="text">
                    <h5>
                      Samantha Francis
                      <span>2 minutes ago</span>
                    </h5>
                    <p>My entire soul, like these sweet mornings of spring.</p>
                  </div>
                </div>
                <div class="msg-box d-flex">
                  <div class="img">
                    <img :src="`${asset}profile.jpg`" alt="profile" />
                  </div>
                  <div class="text">
                    <h5>
                      Donna Seay
                      <span>2 minutes ago</span>
                    </h5>
                    <p>
                      A wonderful serenity has taken possession of my entire
                      soul, like these sweet mornings of spring.
                    </p>
                  </div>
                </div>
                <div class="msg-box d-flex">
                  <div class="img">
                    <img :src="`${asset}profile-2.jpg`" alt="profile" />
                  </div>
                  <div class="text">
                    <h5>
                      Samantha Francis
                      <span>2 minutes ago</span>
                    </h5>
                    <p>My entire soul, like these sweet mornings of spring.</p>
                  </div>
                </div>
                <div class="msg-box d-flex">
                  <div class="img">
                    <img :src="`${asset}profile-2.jpg`" alt="profile" />
                  </div>
                  <div class="text">
                    <h5>
                      Donna Seay
                      <span>2 minutes ago</span>
                    </h5>
                    <p>
                      A wonderful serenity has taken possession of my entire
                      soul, like these sweet mornings of spring.
                    </p>
                  </div>
                </div>
                <div class="msg-box d-flex">
                  <div class="img">
                    <img src="images/profile-2.jpg" alt="profile" />
                  </div>
                  <div class="text">
                    <h5>
                      Samantha Francis
                      <span>2 minutes ago</span>
                    </h5>
                    <p>My entire soul, like these sweet mornings of spring.</p>
                  </div>
                </div>
              </div>
              <div class="btm text-center">
                <a href="#"
                  >Show All Messages <i class="fas fa-chevron-down"></i
                ></a>
              </div>
            </ul>
          </div>
          <div class="profile dropdown">
            <ul
              class="dropdown-toggle"
              id="dropdownMenuButton1"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <li class="profile-image">
                <img :src="`${asset}profile.jpg`" alt="profile" />
              </li>
              <li>
                {{ user?.name }}
                <i class="fas fa-angle-down"></i>
              </li>
            </ul>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li>
                <router-link :to="{ name: 'dashboard' }">
                  <i class="fas fa-cog"></i> Settings
                </router-link>
              </li>
              <li>
                <router-link :to="{ name: 'dashboard' }">
                  <i class="fas fa-user"></i> Profile
                </router-link>
              </li>
              <li>
                <a href="javascript:void(0)" @click="logout()">
                  <i class="fas fa-sign-out-alt"></i> Logout
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    async logout() {
      const res = await this.callApi("post", "logout");
      if (res.status == 200) {
        this.$store.dispatch("auth/logout");
        this.$toast(res.data.message, "success");
        window.location.href = this.$root.baseurl;
      }
    },
  },

  mounted() {
    // collapsed sidebar js
    $(".control-bar i").click(function () {
      $("body").toggleClass("collapsed-menu");
    });

    $(".mobile-control-bar i").click(function () {
      $(".navigation-body").addClass("show-mobile-sidebar");
      body.style.overflow = "hidden";
    });

    $(".mobile-control-bar i").click(function () {
      $(".toggle-overlay").addClass("show-toggle-overlay");
      body.style.overflow = "hidden";
    });

    $(".close-mobile-menu i").click(function () {
      $(".navigation-body").removeClass("show-mobile-sidebar");
      body.style.overflow = "auto";
    });

    $(".close-mobile-menu i").click(function () {
      $(".toggle-overlay").removeClass("show-toggle-overlay");
      body.style.overflow = "auto";
    });

    $(".toggle-overlay").click(function () {
      $(".toggle-overlay").removeClass("show-toggle-overlay");
      body.style.overflow = "auto";
    });

    $(".toggle-overlay").click(function () {
      $(".navigation-body").removeClass("show-mobile-sidebar");
      body.style.overflow = "auto";
    });

    // Request full screen js
    const arrows = document.querySelector(".fa-arrows-alt");
    const body = document.querySelector("body");

    const toggleFullscreen = () => {
      if (document.fullscreenElement) document.exitFullscreen();
      else body.requestFullscreen();
    };

    // arrows.addEventListener("click", toggleFullscreen);
    // setTimeout(() => {
    //   const onChange = () => {
    //     body.className = document.fullscreenElement ? "fullscreen" : "";
    //   };
    //   document.addEventListener("fullscreenchange", onChange);
    // }, 2000);

    // fixed header part js
    $(window).scroll(function () {
      let scrolling = $(this).scrollTop();
      if (scrolling > 0) {
        $(".top-header").addClass("fixed");
      } else {
        $(".top-header").removeClass("fixed");
      }
    });
  },
};
</script>