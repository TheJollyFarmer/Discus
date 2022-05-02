import { getLength, mapKeys } from "../../../helpers/getters";

export default {
  getNotifications: mapKeys,
  getOffset: getLength("keys")
};
