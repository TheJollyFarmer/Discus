import { getLength, mapKeys } from "../../../helpers/getters";

export default {
  getFriends: mapKeys,
  getOffset: getLength("keys")
};
