<script>
export default {
  name: "Broadcast",

  data() {
    return {
      echo: null
    };
  },

  created() {
    this.connect();
  },

  methods: {
    connect() {
      // this.$echo.connector.pusher.connection.bind("connected", event =>
      //   this.connect(event)
      // );
      // this.$echo.connector.pusher.connection.bind("disconnected", () =>
      //   this.disconnect()
      // );
      this.$echo.connector.pusher.connect();
    }
  },

  render(createElement) {
    return createElement("div");
  }
};
</script>
