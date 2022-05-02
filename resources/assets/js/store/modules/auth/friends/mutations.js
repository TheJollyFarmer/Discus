import types from "./types";
import {
  addData,
  pushData,
  setTrue,
  toggleState
} from "../../../helpers/mutations";

export default {
  [types.ADD_DATA]: addData("data"),
  [types.ADD_KEYS]: pushData("keys"),
  toggleProgress: toggleState("progress"),
  setCompleted: setTrue("completed")
};
