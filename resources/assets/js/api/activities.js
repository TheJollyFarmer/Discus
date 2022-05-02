import api from "./index";

export default {
  getActivities(user, offset) {
    return api.request(
      "get",
      api.route("profiles.activities", { user, offset })
    );
  }
};
