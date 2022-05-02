import types from "./types";
import { setState, setProp, toggleProp } from "../../../helpers/mutations";

export default {
  [types.SET_THREAD]: setState("thread"),
  [types.SET_OLD_TITLE]: setState("oldTitle"),
  [types.SET_OLD_BODY]: setState("oldBody"),
  [types.SET_TITLE]: setProp("thread", "title"),
  [types.SET_BODY]: setProp("thread", "body"),
  [types.SET_EDIT_TITLE]: setProp("editForm", "title"),
  [types.SET_EDIT_BODY]: setProp("editForm", "body"),
  [types.SET_FORM_TYPE]: setState("formType"),
  [types.SET_BEST_COMMENT]: setProp("thread", "isBest"),
  [types.TOGGLE_IS_SUBSCRIBED]: toggleProp("thread", "isSubscribed"),
  [types.TOGGLE_IS_LOCKED]: toggleProp("thread", "isLocked"),
  [types.SET_BREADCRUMB_LABEL]: setProp("breadcrumb/thread", "label"),
  [types.SET_CHANNEL_BREADCRUMB_LABEL]: setProp("breadcrumb/channel", "label"),
  [types.SET_CHANNEL_BREADCRUMB_LINK_DATA]: setProp(
    "breadcrumb/channel",
    "linkData"
  )
};
