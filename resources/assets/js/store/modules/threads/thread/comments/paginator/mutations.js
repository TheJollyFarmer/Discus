import types from "./types";
import { setProp, setState } from "../../../../../helpers/mutations";

export default {
  [types.SET_PAGINATOR]: setState("paginator"),
  [types.SET_REQUEST_FORM]: setState("requestForm"),
  [types.UPDATE_PAGE]: setProp("requestForm", "page"),
  [types.UPDATE_PER_PAGE]: setProp("requestForm", "perPage"),
  [types.UPDATE_ORDER_BY]: setProp("requestForm", "orderBy"),
  [types.UPDATE_HASH]: setProp("requestForm", "hash")
};
