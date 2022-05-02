<template>
  <div class="level is-mobile">
    <div class="level-left">
      <slot/>
    </div>
    <div class="level-right">
      <slot name="levelRight"/>
    </div>
  </div>
</template>

<script>
export default {
  name: "VLevel"
};
</script>
