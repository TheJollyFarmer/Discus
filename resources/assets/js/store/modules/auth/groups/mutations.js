import types from "./types";
import Vue from "vue";
import {
  addDatum,
  deleteDatum,
  deleteKey,
  mergeState,
  pushDatum,
  setState,
  toggleDatumProp
} from "../../../helpers/mutations";

export default {
  [types.SET_DATA]: mergeState("data"),
  [types.SET_MAX_GROUPS]: setState("maxGroups"),
  [types.ADD_DATUM]: addDatum("data"),
  [types.ADD_KEY]: pushDatum("keys"),
  [types.SET_GROUP_DISPLAY]: toggleDatumProp("data", "display"),
  [types.ADD_GROUP_USERS]: addGroup,
  [types.DELETE_DATUM]: deleteDatum("data"),
  [types.REMOVE_KEY]: deleteKey("keys"),
  [types.REMOVE_GROUP_USERS]: deleteDatum("groupUsers")
};

function addGroup(state, { id, users }) {
  Vue.set(state.groupUsers, id, users);
}
