export default {
    namespaced: true,

    state: () => ({
        site: {},
        global: {},
        menus: {},
        permissions: {}
    }),

    mutations: {
        setGlobalData(state, data) {
            state.site = data.site;
            state.menus = data.menus;
            state.global = data.global;
            state.permissions = data.permissions;
        },
    },

    actions: {
        setGlobal(context, data) {
            context.commit('setGlobalData', data);
        }
    },
}