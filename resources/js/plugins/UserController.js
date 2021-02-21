import store from '../store/index'
// This is your plugin object. It can be exported to be used anywhere.
const UserController = {
  // The install method is all that needs to exist on the plugin object.
  // It takes the global Vue object as well as user-defined options.
  install(Vue, options) {
    // We call Vue.mixin() here to inject functionality into all components.
    // Anything added to a mixin will be injected into all components.
    Vue.mixin({
      data() {
        return {
          user_scopes: [],
        }
      },

      methods: {
        isUserInScope: function (scope, scopes = store.state.user.user.can) {
          if (scopes.includes(scope)) {
            return true
          }
          return false
        },
      }

    });
  }
};

export default UserController;