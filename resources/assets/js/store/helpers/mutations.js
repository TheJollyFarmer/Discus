import Vue from "vue";
import { getPath } from "../../utils/helpers";

export const setState = key => (state, data) => (state[key] = data);

export const setProp = (path, prop) => (state, data) =>
  Vue.set(getPath(state, path), prop, data);

export const setDatumProp = (key, prop) => (state, { id, value }) =>
  Vue.set(state[key][id], prop, value);

export const addData = key => (state, data) =>
  (state[key] = { ...state[key], ...data });

export const addDatum = key => (state, datum) =>
  Vue.set(state[key], datum.id, datum);

export const unshiftData = key => (state, data) => state[key].unshift(...data);

export const pushData = key => (state, data) => state[key].push(...data);

export const pushDatum = key => (state, datum) => state[key].push(datum);

export const pushDatumProp = (key, prop) => (state, { id, value }) =>
  state[key][id][prop].unshift(value);

export const mergeState = key => (state, data) => Object.assign(state, data);

export const mergeDatum = key => (state, { id, datum }) =>
  (state.data[id] = { ...state.data[id], ...datum });

export const deleteKey = path => (state, key) =>
  Vue.delete(state[path], state[path].indexOf(key));

export const deleteDatum = key => (state, data) => Vue.delete(state[key], data);

export const deleteDatumProp = (key, prop) => (state, { id, value }) =>
  Vue.delete(state[key][id][prop], value);

export const setTrue = key => state => (state[key] = true);

export const setCount = key => (state, count) => (state[key] += count);

export const resetCount = key => (state, count) => (state[key] = 0);

export const incrementCount = key => state => state[key]++;

export const decrementCount = key => state => state[key]--;

export const incrementDatumProp = (key, prop) => (state, id) =>
  Vue.set(state[key][id], prop, state[key][id][prop]++);

export const decrementDatumProp = (key, prop) => (state, id) =>
  Vue.set(state[key][id], prop, state[key][id][prop]--);

export const toggleState = key => state => (state[key] = !state[key]);

export const toggleProp = (path, prop) => state =>
  Vue.set(getPath(state, path), prop, !getPath(state, path)[prop]);

export const toggleDatumProp = (path, prop) => (state, key) =>
  Vue.set(state[path][key], prop, !state[path][key][prop]);
