/* eslint camelcase: "off" */
import { extend, setInteractionMode } from "vee-validate";
import {
  alpha_num,
  min,
  max,
  confirmed,
  image,
  oneOf,
  numeric
} from "vee-validate/dist/rules";

setInteractionMode("eager");

extend("alpha_num", {
  ...alpha_num,
  message: "Indiquez votre {_field_} au bon format"
});

extend("min", {
  ...min,
  message: "Le {_field_} doit contenir au moins {length} caractères"
});

extend("max", {
  ...max,
  message: "Le {_field_} doit contenir au maximum {length} caractères"
});

extend("strongPassword", {
  validate: value => {
    const regex = new RegExp(
      /^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$/
    );
    return regex.test(value);
  },
  message:
    "Votre mot de passe doit contenir au moins 1 majuscule, 1 minuscule, 1 chiffre et 1 charactère spécial"
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

extend("confirmed", {
  ...confirmed,
  message: "Confirmez votre {_field_}"
});

extend("image", {
  ...image,
  message: "Il semble que ce fichier n'est pas au bon format"
});

extend("oneOf ", {
  ...oneOf,
  message: "Choose one"
});

extend("numeric", {
  ...numeric,
  message: "Vous devez saisir un chiffre"
});
