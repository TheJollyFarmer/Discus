import { getValue } from "../../../../../helpers/getters";

export default {
  getPerPage: getValue("requestForm/perPage"),
  getOrderBy: getValue("requestForm/orderBy")
};
