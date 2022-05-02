import api from "./index.js";

export default {
  getMessages(group, offset = 0) {
    return api.request(
      "get",
      api.route("conversations.show", { conversation: group, offset: offset })
    );
  },

  getLatestMessages(offset = 0) {
    return api.request(
      "get",
      api.route("groups.index", { message: "", offset: offset })
    );
  },

  submitMessage({ group, message }) {
    return api.request("post", api.route("conversations.store"), {
      group: group,
      message: message
    });
  },

  deleteMessage(message) {
    return api.request("delete", api.route("conversations.destroy", message));
  }
};
