import types from "./types";
import { setState, setProp } from "../../helpers/mutations";

export default {
  [types.SET_USER]: setState("user"),
  [types.SET_BREADCRUMB_LABEL]: setProp("breadcrumb/user", "label"),
  [types.SET_BREADCRUMB_LINK_DATA]: setProp("breadcrumb/user", "linkData")
};
