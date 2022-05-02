import api from "../index";

export default {
  getChannels(channel, order, offset) {
    return api.request("get", api.route("admin.channels.index"), [
      channel,
      order,
      offset
    ]);
  },

  submitChannel(channel) {
    return api.request("post", api.route("admin.channels.store"), channel);
  },

  updateChannel(channel) {
    return api.request("patch", api.route("admin.channels.update"), channel);
  }
};
