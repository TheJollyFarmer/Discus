import api from "../../../../../api/comments";
import dataStructures from "../../../../../utils/dataStructures";
import types from "./types";
import { getKeys, normalise } from "../../../../../utils/helpers";

export default {
  getData({ dispatch, state }) {
    return api.getComments(state.paginator.requestForm).then(comments => {
      dispatch("addData", comments);
    });
  },

  addData({ commit, dispatch }, paginator) {
    commit(types.SET_COMMENTS, normalise(paginator.data, "comments"));
    commit(types.SET_KEYS, getKeys(paginator.data));

    dispatch("setReplies", Object.values(paginator.data));
    dispatch("paginator/setPaginator", dataStructures.paginator(paginator));
  },

  setReplies({ commit }, comments) {
    for (const comment of comments) {
      if (comment.replies.length) {
        commit(
          types.SET_REPLIES,
          normalise(comment.replies, "comments", "replies")
        );
      }
    }
  },

  submitComment({ commit }, payload) {
    return api.submitComment(payload).then(comment => {
      commit(types.ADD_COMMENT, dataStructures.comments(comment));
      commit(types.ADD_KEY, comment.id);
    });
  },

  submitReply({ dispatch }, payload) {
    return api.submitComment(payload).then(reply => {
      dispatch("addReply", dataStructures.comments(reply));
    });
  },

  addReply({ commit, getters }, reply) {
    commit(types.ADD_REPLY, reply);
    commit(types.ADD_KEY_TO_PARENT, {
      id: reply.parent,
      value: reply.id
    });
  },

  updateBody({ commit, getters }, payload) {
    return api.updateBody(payload).then(() => {
      commit(types.UPDATE_BODY, {
        id: payload.reply,
        value: payload.body
      });
    });
  },

  deleteComment({ commit, dispatch, getters }, { id, parent }) {
    return api.deleteComment(id).then(() => {
      commit(types.DELETE_COMMENT, id);
      parent
        ? dispatch("deleteReplyKey", { id, parent })
        : dispatch("deleteKey", id);
    });
  },

  deleteKey({ commit, dispatch }, id) {
    commit(types.DELETE_KEY, id);
    dispatch("getData");
  },

  deleteReplyKey({ commit, state }, { id, parent }) {
    commit(types.DELETE_REPLY_KEY, {
      id: parent,
      value: state[parent].replies.indexOf(id)
    });
  },

  favouriteComment({ commit, getters, state }, id) {
    return api.favouriteComment(id).then(() => {
      commit(types.TOGGLE_FAVOURITE_COMMENT, id);
      commit(types.INCREMENT_FAVOURITE_COUNT, id);
    });
  },

  unfavouriteComment({ commit, getters, state }, id) {
    return api.unfavouriteComment(id).then(() => {
      commit(types.TOGGLE_FAVOURITE_COMMENT, id);
      commit(types.DECREMENT_FAVOURITE_COUNT, id);
    });
  },

  toggleContent({ commit, getters }, id) {
    commit(types.TOGGLE_CONTENT, id);
  }
};
