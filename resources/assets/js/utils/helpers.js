import dataStructures from "./dataStructures";

export function normalise(array, model, children, pivot) {
  return array.reduce(
    (obj, item) => ({
      ...obj,
      ...{ [getId(pivot, item)]: dataStructures[model](item) },
      ...(children ? normalise(item[children], model, children) : "")
    }),
    {}
  );
}

export function getKeys(array, pivot = false) {
  return array.map(item => getId(pivot, item));
}

export function hasLength(data) {
  return Array.isArray(data) ? data.length : Object.keys(data).length;
}

export function getPath(obj, path) {
  return path.split("/").reduce((obj, name) => obj[name], obj);
}

function getId(pivot, item) {
  return pivot ? item.pivot.id : item.id;
}
