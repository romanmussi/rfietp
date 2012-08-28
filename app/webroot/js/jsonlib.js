function array1dToJson(a) {
  var s = '{';
  var i = 0;

  jQuery.each(a, function(key, value) {
        if (typeof value == 'string') {
          v = '"' + value + '"';
        }
        else { // assume number type
          v = value;
        }

        s += '"' + key + '":' + v + ",";

        i++;
  })
  s = s.substr(0, s.length-1) + '}';

  return s;
}

function array2dToJson(a, p) {
  var i;
  //var s = '[{"' + p + '":';
  var s = '[';

  jQuery.each(a, function(key, value) {
      s += array1dToJson(value);

      if (key < a.length - 1) {
          s += ',';
        }
  });

  s += ']';
  return s;

}