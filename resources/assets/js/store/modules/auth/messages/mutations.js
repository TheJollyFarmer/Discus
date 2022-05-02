import types from "./types";
import {
  addData,
  addDatum,
  decrementCount,
  incrementCount,
  pushData,
  pushDatum,
  resetCount,
  setCount,
  setDatumProp,
  setTrue,
  toggleState
} from "../../../helpers/mutations";

export default {
  [types.ADD_DATA]: addData("data"),
  [types.ADD_KEYS]: pushData("keys"),
  [types.ADD_DATUM]: addDatum("data"),
  [types.ADD_KEY]: pushDatum("key"),
  [types.UPDATE_KEY]: updateKey,
  [types.UPDATE_MESSAGE]: addDatum("data"),
  [types.SET_AS_READ]: setDatumProp("data", "read"),
  [types.SET_AS_UNREAD]: setDatumProp("data", "read"),
  [types.SET_UNREAD_COUNT]: setCount("unreadCount"),
  [types.INCREMENT_UNREAD_COUNT]: incrementCount("unreadCount"),
  [types.DECREMENT_UNREAD_COUNT]: decrementCount("unreadCount"),
  [types.SET_UNREAD_COUNT_TO_ZERO]: resetCount("unreadCount"),
  [types.TOGGLE_PROGRESS]: toggleState("progress"),
  [types.SET_COMPLETED]: setTrue("completed")
};

function updateKey(state, group) {
  state.keys.splice(0, 0, state.keys.splice(state.keys.indexOf(group), 1)[0]);
}
