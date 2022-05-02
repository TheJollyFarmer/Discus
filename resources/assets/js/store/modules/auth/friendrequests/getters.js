import { getLength, mapKeys } from "../../../helpers/getters";

export default {
  getRequests: mapKeys,
  getOffset: getLength("keys")
};
