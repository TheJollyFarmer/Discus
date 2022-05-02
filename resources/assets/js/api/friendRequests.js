import api from "./index.js";

export default {
  getFriendRequests(auth, offset = 0) {
    return api.request(
      "get",
      api.route("friendships.index", {
        user: auth,
        type: "pending",
        offset: offset
      })
    );
  },

  acceptFriendRequest(friendship) {
    return api.request("patch", api.route("friendships.update", friendship));
  },

  declineFriendRequest(friendship) {
    return api.request("delete", api.route("friendships.destroy", friendship));
  }
};
