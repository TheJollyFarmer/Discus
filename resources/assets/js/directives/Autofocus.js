export default (el, binding) => {
  if (binding.value) {
    setTimeout(() => {
      el.focus();

      if (el.value && el.type !== "email") {
        el.setSelectionRange(el.value.length, el.value.length);
      }
    }, 200);
  }
};
