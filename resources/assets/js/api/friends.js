import api from "./index.js";

export default {
  getFriends(auth, offset) {
    return api.request(
      "get",
      api.route("friendships.index", { user: auth, offset: offset })
    );
  }
};
