export default {
  data() {
    return {
      href: false
    };
  },

  methods: {
    handler() {
      if (this.notification.data.link) {
        return (location.href = this.notification.data.link);
      }
      this.getLink();
      this.markAsRead();
    },

    baseUrl() {
      return `/replies/${this.notification.data.reply_id}`;
    },

    queryUrl() {
      let perPage = sessionStorage.getItem("per-page");
      let orderBy = sessionStorage.getItem("order-by");

      return `?per-page=${perPage}&order-by=${orderBy}`;
    },

    getLink() {
      axios
        .get(this.baseUrl() + this.queryUrl())
        .then(response => {
          this.setLink(response);
        })
        .catch(error);
    },

    setLink(response) {
      let threadId = location.pathname.match(/[\d]+/);

      if (threadId === this.notification.data.thread_id) {
        return events.$emit("fetch", {
          page: response.data.page,
          hash: response.data.hash
        });
      }
      location.href = response.data.link;
    }
  }
};
