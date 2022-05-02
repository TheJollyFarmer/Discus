import types from "./types";
import {
  addData,
  addDatum,
  decrementDatumProp,
  deleteDatum,
  deleteDatumProp,
  deleteKey,
  incrementDatumProp,
  pushDatum,
  pushDatumProp,
  setDatumProp,
  setState,
  toggleDatumProp
} from "../../../../helpers/mutations";

export default {
  [types.SET_COMMENTS]: setState("data"),
  [types.SET_REPLIES]: addData("data"),
  [types.SET_KEYS]: setState("keys"),
  [types.ADD_COMMENT]: addDatum("data"),
  [types.ADD_REPLY]: addDatum("data"),
  [types.ADD_KEY]: pushDatum("keys"),
  [types.ADD_KEY_TO_PARENT]: pushDatumProp("data", "replies"),
  [types.DELETE_COMMENT]: deleteDatum("data"),
  [types.DELETE_KEY]: deleteKey("keys"),
  [types.DELETE_REPLY_KEY]: deleteDatumProp("data", "replies"),
  [types.UPDATE_BODY]: setDatumProp("data", "body"),
  [types.TOGGLE_FAVOURITE_COMMENT]: toggleDatumProp("data", "isFavourited"),
  [types.INCREMENT_FAVOURITE_COUNT]: incrementDatumProp("data", "favourites"),
  [types.DECREMENT_FAVOURITE_COUNT]: decrementDatumProp("data", "favourites"),
  [types.TOGGLE_CONTENT]: toggleDatumProp("data", "showContent")
};
