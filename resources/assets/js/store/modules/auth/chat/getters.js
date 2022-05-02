import { getLength, mapKeys } from "../../../helpers/getters";

export default {
  getMessages: mapKeys,
  getOffset: getLength("keys")
};
