import api from "../index";

export default {
  getThreads(order, offset) {
    return api.request("get", api.route("admin.threads.index"), [
      order,
      offset
    ]);
  },

  updateThread(thread) {
    return api.request("patch", api.route("admin.threads.update"), thread);
  }
};
