import { getLength, isTrue, mapKeys } from "../../helpers/getters";

export default {
  getThreads: mapKeys,
  getOffset: getLength("keys"),
  isActiveFilter: isTrue("filter"),
  getFilterName: state =>
    state.filter.channel
      ? state.filter.channel.toUpperCase()
      : Object.keys(state.filter)[0]
        ? Object.keys(state.filter)[0].toUpperCase()
        : "All"
};
