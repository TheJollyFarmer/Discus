import api from "./index";

export default {
  createGroup(payload) {
    return api.request("post", api.route("groups.store"), payload);
  },

  deleteGroup(group) {
    return api.request("delete", api.route("groups.destroy", group));
  },

  leaveGroup(group) {
    return api.request("delete", api.route("groups.destroy", [group, "leave"]));
  },

  addFriends({ group, users }) {
    return api.request("patch", api.route("groups.update", group), {
      users: users
    });
  },

  getGroups() {
    return api.getItem("session", "groups") || {};
  },

  setGroups(state) {
    api.setItem("session", "groups", state);
  }
};
