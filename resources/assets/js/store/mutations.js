import types from "./types";
import { pushData, setState, toggleState } from "./helpers/mutations";

export default {
  [types.SET_CHANNELS]: setState("channels"),
  [types.SET_OVERLAY]: setState("displayOverlay"),
  [types.TOGGLE_MODAL]: toggleState("displayModal"),
  [types.SET_MODAL]: setState("modal"),
  [types.SET_MODAL_IMAGE]: setState("modalImage"),
  [types.SET_ERRORS]: setState("errors"),
  [types.ADD_BREADCRUMBS]: pushData("breadcrumbs"),
  [types.REPLACE_BREADCRUMB]: replaceBreadcrumb,
  [types.TOGGLE_USER_PANEL]: toggleState("displayUserPanel")
};

function replaceBreadcrumb(state, breadcrumb) {
  state.breadcrumbs.splice(state.breadcrumbs.length - 1, 1, breadcrumb);
}