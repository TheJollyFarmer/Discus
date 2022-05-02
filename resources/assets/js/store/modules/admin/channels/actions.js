import types from "./types";
import { getKeys, normalise } from "../../../../utils/helpers";

export default {
  setChannels({ commit }, channels) {
    commit(types.SET_DATA, normalise(channels, "channels"));
    commit(types.SET_KEYS, getKeys(channels));
  },

  editChannel({ commit, dispatch }, channel) {
    commit(types.SET_DATUM, channel);

    dispatch(
      "openModal",
      { type: "ChannelForm", image: "default" },
      { root: true }
    );
  }
};
