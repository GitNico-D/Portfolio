/* eslint camelcase: "off" */
import { extend, setInteractionMode } from "vee-validate";
import {
  min,
  max,
  image,
  numeric
} from "vee-validate/dist/rules";

setInteractionMode("eager");

extend("min", {
  ...min,
  message: "Le {_field_} doit contenir au moins {length} caractères"
});

extend("max", {
  ...max,
  message: "Le {_field_} doit contenir au maximum {length} caractères"
});

extend("url", {
  validate: value => {
    const regex = new RegExp(
      /^(http|ftp|https)?(:\/\/)?[\w-]+(\.[\w-]+)+([\w.,@?^!=%&amp;:/~+#-]*[\w@?^=%&amp;/~+#-])+$/
    );
    return regex.test(value);
  },
  message: "Veuillez remplir une url valide"
});

extend("image", {
  ...image,
  message: "Il semble que ce fichier n'est pas au bon format"
});

extend("numeric", {
  ...numeric,
  message: "Vous devez saisir un chiffre"
});
