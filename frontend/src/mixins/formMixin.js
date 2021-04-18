export default {
  methods: {
    setFormWithFile(file, form) {
      const formData = new FormData();
      Object.entries(form).forEach(([key, value]) => {
        if (
          value !== null &&
          value !== "" &&
          key !== "id" &&
          key !== "contacts"
        ) {
          formData.append(`${key}`, value);
        }
      });
      return formData;
    }
  }
};
