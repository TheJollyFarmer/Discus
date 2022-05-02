<template>
  <nav class="panel">
    <p 
      v-if="heading" 
      class="panel-heading">
      {{ heading }}
    </p>
    <slot/>
  </nav>
</template>

<script>
export default {
  name: "VPanel",

  props: {
    heading: {
      type: String,
      required: false,
      default: ""
    }
  }
};
</script>
