import api from "./index.js";

export default {
  getNotifications(auth, offset = 0) {
    return api.request(
      "get",
      api.route("notifications.index", { user: auth, offset: offset })
    );
  },

  markAllAsRead(user) {
    return api.request("delete", api.route("notifications.destroy", user));
  },

  markAs(user, id, query) {
    return api.request(
      "patch",
      api.route("notifications.update", {
        user: user,
        notification: id,
        unmark: query
      })
    );
  },

  generateLink(reply) {
    return api.request(
      "get",
      api.route("replies.show", {
        reply: reply,
        "per-page": api.getItem("local", "requestForm").perPage,
        "order-by": api.getItem("local", "requestForm").orderBy
      })
    );
  },

  goToThread(channel, slug, payload) {
    let requestForm = {
      ...api.getItem("local", "requestForm"),
      ...payload
    };

    api.setItem("local", "requestForm", requestForm);

    return api.goTo("threads.show", [channel, slug]);
  }
};
