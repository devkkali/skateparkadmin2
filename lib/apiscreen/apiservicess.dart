import 'dart:convert';
import 'package:http/http.dart' as http;

class ApiServices {
  Future getAllpost() async {
    final allProductUrl = Uri.parse('https://fakestoreapi.com/products');
    final response = await http.get(allProductUrl);
    print(response.statusCode);
    print(response.body);
    return jsonDecode(response.body);
  }
}
