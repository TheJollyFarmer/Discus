export default {
  data() {
    return {
      items: []
    };
  },

  methods: {
    add(reply) {
      events.$emit("added");

      if (!reply.parent_id) {
        if (this.orderBy !== "created_at,desc") {
          if (this.dataSet.total === this.perPage * this.dataSet.last_page) {
            return this.fetch(this.dataSet.last_page + 1);
          }
          return this.fetch(this.dataSet.last_page);
        }
        return this.fetch(1);
      }
      this.items.unshift(reply);
    },

    remove(index, reply) {
      events.$emit("removed");

      if (!reply.parent_id) {
        if (this.lastPage() && this.items.length === 1) {
          return setTimeout(() => this.fetch(this.dataSet.last_page - 1), 100);
        }
        return setTimeout(() => this.fetch(this.dataSet.current_page), 100);
      }
      this.items.splice(index, 1);
    }
  }
};
