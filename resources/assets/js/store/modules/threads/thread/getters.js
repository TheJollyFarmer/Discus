import { getValue, isEqualTo, isTrue } from "../../../helpers/getters";

export default {
  getSlug: getValue("thread/slug"),
  getChannelSlug: getValue("thread/channelSlug"),
  getOwner: getValue("thread/user"),
  getEditTitle: getValue("editForm/title"),
  getEditBody: getValue("editForm/body"),
  isEditing: isEqualTo("formType", "editing"),
  isBestComment: isTrue("thread/isBest"),
  isThreadLocked: getValue("thread/isLocked")
}