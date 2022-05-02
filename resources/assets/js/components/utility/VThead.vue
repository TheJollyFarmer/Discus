<template>
  <thead>
    <tr>
      <th
        v-for="head in header"
        :key="head">
        {{ head }}
      </th>
    </tr>
  </thead>
</template>

<script>
export default {
  name: "VTHead",

  props: {
    header: {
      type: Array,
      required: true
    }
  }
};
</script>
