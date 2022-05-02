import types from "./types";
import {
  addData,
  addDatum,
  decrementCount,
  deleteDatum,
  incrementCount,
  pushData,
  pushDatum,
  setTrue,
  toggleState
} from "../../../helpers/mutations";

export default {
  [types.ADD_DATA]: addData("data"),
  [types.ADD_KEYS]: pushData("keys"),
  [types.ADD_DATUM]: addDatum("data"),
  [types.ADD_KEY]: pushDatum("keys"),
  [types.DELETE_DATUM]: deleteDatum("keys"),
  [types.INCREMENT_UNREAD_COUNT]: incrementCount("unreadCount"),
  [types.DECREMENT_UNREAD_COUNT]: decrementCount("unreadCount"),
  [types.TOGGLE_PROGRESS]: toggleState("progress"),
  [types.SET_COMPLETED]: setTrue("completed")
};
