import { getPath } from "../../utils/helpers";

export const mapKeys = state => state.keys.map(key => state.data[key]);
export const getKeys = path => state => getPath(state, path);
export const getValue = path => state => getPath(state, path);
export const getDatum = path => state => key => getPath(state, path)[key];
export const getDatumProp = (path, prop) => state => key =>
  getPath(state, path)[key][prop];
export const getObjValues = path => state => key =>
  Object.values(getPath(state, path)[key]);
export const getLength = key => state => state[key].length;
export const isTrue = path => state => value => getPath(state, path) === value;
export const isFalse = path => state => value => getPath(state, path) !== value;
export const isEqualTo = (path, value) => state =>
  getPath(state, path) === value;
export const isEqualToProp = (path, value, prop) => state => key =>
  getPath(state, path)[key][prop] === value;
export const isNotEqualTo = (path, value) => state =>
  getPath(state, path) !== value;
