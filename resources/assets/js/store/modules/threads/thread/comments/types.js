import types from "../../../../helpers/types";

export default {
  SET_COMMENTS: "setComments",
  SET_REPLIES: "setReplies",
  SET_KEYS: types.SET_KEYS,
  ADD_COMMENT: "addComment",
  ADD_REPLY: "addReply",
  ADD_KEY: types.ADD_KEY,
  ADD_KEY_TO_PARENT: "addKeyToParent",
  DELETE_COMMENT: "deleteComment",
  DELETE_KEY: types.DELETE_KEY,
  UPDATE_BODY: "updateBody",
  DELETE_REPLY_KEY: "deleteReplyKey",
  TOGGLE_FAVOURITE_COMMENT: "toggleFavouriteComment",
  INCREMENT_FAVOURITE_COUNT: "incrementFavouriteCount",
  DECREMENT_FAVOURITE_COUNT: "decrementFavouriteCount",
  TOGGLE_CONTENT: types.TOGGLE_CONTENT
};
