import filters from "../utils/filters";

export default {
  bind(el, { value, oldValue, arg, modifiers }) {
    if (isValid(value, oldValue)) {
      let node = createNode();

      createContent(value, node, modifiers.list);
      addClasses(value, node, arg, el);
    }
  },

  update(el, { value, oldValue, modifiers }) {
    if (isValid(value, oldValue)) {
      createContent(value, createNode(), modifiers.list);
    }
  }
};

// Helpers
function isValid(data, oldData) {
  return data.length && oldData !== data;
}

function createNode() {
  return document.createElement("div");
}

function createContent(data, node, list) {
  list ? createList(data, node) : createLabel(data, node);
}

function createList(dataList, node) {
  for (const item of dataList) {
    let list = node.appendChild(document.createElement("div"));
    let listItem = document.createTextNode(item.user);

    list.appendChild(listItem);
  }
}

function createLabel(data, node) {
  node.appendChild(document.createTextNode(filters.capitalise(data)));
}

function addClasses(data, node, arg, el) {
  if (data.length > 40) node.classList.add("tooltip-multiline");

  let position = arg || "top";

  node.classList.add("tooltip", "tooltip-" + position);

  el.classList.add("tooltip-container");
  el.appendChild(node);
}
