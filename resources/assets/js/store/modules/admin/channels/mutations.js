import types from "./types";
import { setState } from "../../../helpers/mutations";

export default {
  [types.SET_DATA]: setState("data"),
  [types.SET_KEYS]: setState("keys"),
  [types.SET_DATUM]: setState("channelForm")
};
