import types from "./types";
import {
  addData,
  addDatum,
  deleteDatum,
  deleteKey,
  pushDatum,
  setTrue,
  toggleState,
  unshiftData
} from "../../../helpers/mutations";

export default {
  [types.ADD_DATA]: addData("data"),
  [types.ADD_KEYS]: unshiftData("keys"),
  [types.ADD_KEY]: pushDatum("keys"),
  [types.ADD_DATUM]: addDatum("data"),
  [types.DELETE_KEY]: deleteKey("keys"),
  [types.DELETE_DATUM]: deleteDatum("data"),
  [types.TOGGLE_PROGRESS]: toggleState("progress"),
  [types.SET_COMPLETED]: setTrue("completed")
};
