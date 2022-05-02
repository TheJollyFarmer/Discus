import {
  addData,
  pushData,
  setState,
  setTrue,
  toggleState,
  toggleDatumProp
} from "../../helpers/mutations";
import types from "./types";

export default {
  [types.SET_DATA]: setState("data"),
  [types.SET_KEYS]: setState("keys"),
  [types.ADD_DATA]: addData("data"),
  [types.ADD_KEYS]: pushData("keys"),
  [types.TOGGLE_PROGRESS]: toggleState("progress"),
  [types.SET_COMPLETED]: setTrue("completed"),
  [types.SET_FILTER]: setState("filter"),
  [types.SET_BREADCRUMB]: setState("breadcrumb"),
  [types.TOGGLE_CONTENT]: toggleDatumProp("data", "showContent")
};
