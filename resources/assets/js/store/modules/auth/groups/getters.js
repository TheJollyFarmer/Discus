import {
  getDatumProp,
  getLength,
  getObjValues,
  isEqualTo,
  isEqualToProp
} from "../../../helpers/getters";

export default {
  getGroupUsers: getObjValues("groupUsers"),
  getGroupDisplay: getDatumProp("data", "display"),
  getIsMaxGroups: isEqualTo("maxGroups", getLength("keys")),
  getIsGroupType: isEqualToProp("data", "group", "type"),
  getFilteredUsers: (state, getters, rootState) => users =>
    users.filter(user => user.id !== rootState.auth.user.id)
};
