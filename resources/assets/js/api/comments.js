import api from "./index.js";
import store from "../store/index";

export default {
  getComments({ page, perPage, orderBy }) {
    return api.request(
      "get",
      api.route("replies.index", {
        channel: store.getters["threads/thread/getChannelSlug"],
        thread: store.getters["threads/thread/getSlug"],
        page: page,
        "per-page": perPage,
        "order-by": orderBy
      })
    );
  },

  submitComment(comment) {
    return api.request(
      "post",
      api.route("replies.store", {
        channel: store.getters["threads/thread/getChannelSlug"],
        thread: store.getters["threads/thread/getSlug"]
      }),
      comment
    );
  },

  updateBody(comment) {
    return api.request("patch", api.route("replies.update", comment));
  },

  deleteComment(comment) {
    return api.request("delete", api.route("replies.destroy", comment));
  },

  favouriteComment(comment) {
    return api.request("post", api.route("favourites.store", comment));
  },

  unfavouriteComment(comment) {
    return api.request("delete", api.route("favourites.destroy", comment));
  }
};
