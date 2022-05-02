import api from "./index.js";
import store from "../store/index";

export default {
  updateThread({ title, body }) {
    return api.request(
      "patch",
      api.route("threads.update", {
        channel: store.getters["threads/thread/getChannelSlug"],
        thread: store.getters["threads/thread/getSlug"]
      }),
      {
        title,
        body
      }
    );
  },

  setBestComment(comment) {
    return api.request("post", api.route("best-comments.store", comment));
  },

  unsetBestComment(comment) {
    return api.request("patch", api.route("best-comments.store", comment));
  },

  subscribeToThread(thread) {
    return api.request(
      "post",
      api.route("thread-subscriptions.store", {
        channel: store.getters["threads/thread/getChannelSlug"],
        thread
      })
    );
  },

  unsubscribeToThread(thread) {
    return api.request(
      "delete",
      api.route("thread-subscriptions.destroy", {
        channel: store.getters["threads/thread/getChannelSlug"],
        thread
      })
    );
  },

  lockThread(thread) {
    return api.request("post", api.route("locked-threads.store", thread));
  },

  unlockThread(thread) {
    return api.request("delete", api.route("locked-threads.destroy", thread));
  },

  deleteThread(thread) {
    return api.request(
      "delete",
      api.route("threads.destroy", {
        channel: store.getters["threads/thread/getChannelSlug"],
        thread
      })
    );
  },

  goToHome() {
    return api.goTo("threads.index");
  }
};
