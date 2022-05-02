import api from "./index";

export default {
  getThreads(filter, offset) {
    return api.request(
      "get",
      api.route("threads.index", {
        [Object.keys(filter)]: Object.values(filter),
        offset: offset
      })
    );
  },

  goToThreads(filter) {
    api.goTo("threads.index");
  },

  getFilter(filter) {
    return api.getItem("session", "threadFilter") || "";
  },

  setFilter(filter) {
    return api.setItem("session", "threadFilter", filter);
  },

  isThreadsRoute() {
    let route = api.currentRoute();

    return route === "threads.index" || route === undefined;
  }
};
