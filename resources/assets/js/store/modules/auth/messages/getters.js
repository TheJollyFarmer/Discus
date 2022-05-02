import { getLength, mapKeys } from "../../../helpers/getters";

export default {
  getMessages: mapKeys,
  getOffset: getLength("keys"),
  getLatestMessages: state => array => array.filter(item => item.latest_message)
};
