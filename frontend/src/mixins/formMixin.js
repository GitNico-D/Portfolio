export default {
  methods: {
    setFormWithFile(file, form) {
      const formData = new FormData();
      formData.append('imgStatic', file);
      Object.entries(form).forEach(
        ([key, value]) => {
          if (value !== null && value !== '' && key !== "id") {
            formData.append(`${key}`, value);
          }
        }
      );
      return formData;
    }
  },
}