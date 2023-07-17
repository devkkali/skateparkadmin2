import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:skatepark/userid.dart';
import 'dart:async';
import 'package:intl/intl.dart';

import 'details.dart';

class Home extends StatefulWidget {
  final String cardnumber, roshan;
  Home(this.cardnumber, this.roshan);

  @override
  State<Home> createState() => _HomeState();
}

class _HomeState extends State<Home> {
  double? indicatorValue;
  Timer? timer;

  String time() {
    return "${DateTime.now().hour < 10 ? "0${DateTime.now().hour}" : DateTime.now().hour} : ${DateTime.now().minute < 10 ? "0${DateTime.now().minute}" : DateTime.now().minute} : ${DateTime.now().second < 10 ? "0${DateTime.now().second}" : DateTime.now().second} ";
  }

  updateSeconds() {
    timer = Timer.periodic(
        Duration(seconds: 1),
        (Timer timer) => setState(() {
              indicatorValue = DateTime.now().second / 60;
            }));
  }

  @override
  void initState() {
    super.initState();
    indicatorValue = DateTime.now().second / 60;
    updateSeconds();
  }

  @override
  void dispose() {
    timer!.cancel();
    super.dispose();
  }

  int _itemcount = 0;
  int _add = 0;
  void _incresewater() {
    setState(() => _add++);
  }

  void _decreseewater() {
    setState(() => _add--);
  }

  void _incrementalCount() {
    setState(() => _itemcount++);
  }

  void _decrementCount() {
    setState(() => _itemcount--);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Colors.grey,
        title: Padding(
          padding:
              EdgeInsets.only(left: MediaQuery.of(context).size.width * 0.2),
          child: Text('The Skate Park'),
        ),
        leading: Center(
          child: Center(
            child: IconButton(
              icon: Icon(
                Icons.arrow_back,
                color: Colors.white,
              ),
              onPressed: () {
                Navigator.pushReplacement(
                    context, MaterialPageRoute(builder: (contex) => UserId()));
                // do something
              },
            ),
          ),
        ),
      ),
      body: SingleChildScrollView(
        child: Column(
          children: [
            Container(
              child: Center(
                child: Padding(
                  padding: EdgeInsets.only(top: 8.0, left: 20.0),
                  child: Text(
                    widget.cardnumber,
                    style: TextStyle(
                      color: Colors.blue,
                      fontSize: 50,
                    ),
                  ),
                ),
              ),
            ),
            Column(
              children: [
                Text(
                  'Roshan',
                  style: TextStyle(fontSize: 30.0, color: Colors.black54),
                ),
              ],
            ),
            Column(
              children: [
                Text(
                  time(),
                  style: TextStyle(fontSize: 30.0, color: Colors.red),
                ),
              ],
            ),
            Row(
              children: [
                Expanded(
                  child: Container(
                    margin: EdgeInsets.only(left: 10.0, right: 15.0),
                    child: Divider(color: Colors.black54, thickness: 1.2),
                  ),
                ),
              ],
            ),
            ListTileTheme(
              child: ListTile(
                title: Text(
                  'Entry Details',
                  style: TextStyle(
                      color: Colors.green,
                      fontSize: 25.0,
                      fontWeight: FontWeight.bold),
                ),
              ),
            ),
            ListTileTheme(
              child: ListTile(
                tileColor: Colors.white70,
                trailing: Text(
                  'Normal',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
                title: Text(
                  'Client Type:',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
              ),
            ),
            ListTileTheme(
              child: ListTile(
                tileColor: Colors.black12,
                trailing: Text(
                  'Bhawana Bhandari',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
                title: Text(
                  'Name',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
              ),
            ),
            ListTileTheme(
              child: ListTile(
                tileColor: Colors.white70,
                trailing: Text(
                  '9845554566',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
                title: Text(
                  'Phone No:',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
              ),
            ),
            ListTileTheme(
              child: ListTile(
                tileColor: Colors.black12,
                trailing: Text(
                  '2022/01/12',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
                title: Text(
                  'Date:',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
              ),
            ),
            ListTileTheme(
              child: ListTile(
                tileColor: Colors.white70,
                trailing: Text(
                  '2:15:20',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
                title: Text(
                  'Time:',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
              ),
            ),
            ListTileTheme(
              child: ListTile(
                title: Text(
                  'Exit Details',
                  style: TextStyle(
                      color: Colors.brown,
                      fontSize: 25.0,
                      fontWeight: FontWeight.bold),
                ),
              ),
            ),
            ListTileTheme(
              child: ListTile(
                tileColor: Colors.black12,
                trailing: Text(
                  '2022/01/12',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
                title: Text(
                  'Date:',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
              ),
            ),
            ListTileTheme(
              child: ListTile(
                tileColor: Colors.white70,
                trailing: Text(
                  '2:15:20',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
                title: Text(
                  'Time:',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
              ),
            ),
            ListTileTheme(
              child: ListTile(
                title: Text(
                  'Payment Details',
                  style: TextStyle(
                      color: Colors.purple,
                      fontSize: 25.0,
                      fontWeight: FontWeight.bold),
                ),
              ),
            ),
            ListTileTheme(
              child: ListTile(
                tileColor: Colors.black12,
                trailing: Text(
                  '2:15:20',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
                title: Text(
                  'Interval:',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
              ),
            ),
            ListTileTheme(
              child: ListTile(
                tileColor: Colors.white70,
                trailing: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    IconButton(
                      onPressed: _decrementCount,
                      icon: Icon(Icons.remove_circle_outlined),
                      color: Colors.blueAccent,
                      iconSize: 30,
                    ),
                    Text(
                      _itemcount.toString(),
                      style: TextStyle(fontSize: 25.0),
                    ),
                    IconButton(
                      onPressed: _incrementalCount,
                      icon: Icon(
                        Icons.add_circle_outlined,
                        color: Colors.blueAccent,
                        size: 30,
                      ),
                    ),
                  ],
                ),
                title: Text(
                  'Number of clients:',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
              ),
            ),
            ListTileTheme(
              child: ListTile(
                tileColor: Colors.black12,
                trailing: Text(
                  '2:15:20',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
                title: Text(
                  'Time:',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
              ),
            ),
            ListTileTheme(
              child: ListTile(
                tileColor: Colors.white70,
                trailing: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Text(
                      _itemcount.toString(),
                      style: TextStyle(fontSize: 25.0),
                    ),
                    SizedBox(
                      width: 20,
                    ),
                    ElevatedButton(
                      onPressed: () {},
                      child: Text('Add'),
                      style: ButtonStyle(
                          backgroundColor:
                              MaterialStateProperty.all<Color>(Colors.green)),
                    ),
                    SizedBox(
                      width: 20,
                    ),
                    ElevatedButton(
                      style: ButtonStyle(
                          backgroundColor:
                              MaterialStateProperty.all<Color>(Colors.grey)),
                      onPressed: () {},
                      child: Text(
                        'Edit',
                      ),
                    )
                  ],
                ),
                title: Text(
                  'Water Bottle:',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
              ),
            ),
            ListTileTheme(
              child: ListTile(
                tileColor: Colors.black12,
                trailing: Text(
                  'Rs 215',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
                title: Text(
                  'Water Cost',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
              ),
            ),
            ListTileTheme(
              child: ListTile(
                tileColor: Colors.white70,
                trailing: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Text(
                      _itemcount.toString(),
                      style: TextStyle(fontSize: 25.0),
                    ),
                    SizedBox(
                      width: 20,
                    ),
                    ElevatedButton(
                      onPressed: () {},
                      child: Text('Add'),
                      style: ButtonStyle(
                          backgroundColor:
                              MaterialStateProperty.all<Color>(Colors.green)),
                    ),
                    SizedBox(
                      width: 20,
                    ),
                    ElevatedButton(
                      style: ButtonStyle(
                          backgroundColor:
                              MaterialStateProperty.all<Color>(Colors.grey)),
                      onPressed: () {},
                      child: Text(
                        'Edit',
                      ),
                    )
                  ],
                ),
                title: Text(
                  'Water Bottle:',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
              ),
            ),
            ListTileTheme(
              child: ListTile(
                tileColor: Colors.black12,
                trailing: Text(
                  'Rs 215',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
                title: Text(
                  'Water Cost',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
              ),
            ),
            ListTileTheme(
              child: ListTile(
                tileColor: Colors.white70,
                trailing: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Text(
                      _itemcount.toString(),
                      style: TextStyle(fontSize: 25.0),
                    ),
                    SizedBox(
                      width: 20,
                    ),
                    ElevatedButton(
                      onPressed: () {},
                      child: Text('Add'),
                      style: ButtonStyle(
                          backgroundColor:
                              MaterialStateProperty.all<Color>(Colors.green)),
                    ),
                    SizedBox(
                      width: 20,
                    ),
                    ElevatedButton(
                      style: ButtonStyle(
                          backgroundColor:
                              MaterialStateProperty.all<Color>(Colors.grey)),
                      onPressed: () {},
                      child: Text(
                        'Edit',
                      ),
                    )
                  ],
                ),
                title: Text(
                  'Water Bottle:',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
              ),
            ),
            ListTileTheme(
              child: ListTile(
                tileColor: Colors.black12,
                trailing: Text(
                  '215',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
                title: Text(
                  'Deposited Amount',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
              ),
            ),
            ListTileTheme(
              child: ListTile(
                tileColor: Colors.white70,
                trailing: SizedBox(
                  child: TextField(
                    inputFormatters: [FilteringTextInputFormatter.digitsOnly],
                    decoration: InputDecoration(
                        fillColor: Colors.grey.shade100,
                        filled: true,
                        border: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(10))),
                    autofocus: false,
                  ),
                  width: 100,
                  height: 30,
                ),
                title: Text(
                  'Discount Amount',
                  style: TextStyle(
                    fontSize: 20.0,
                  ),
                ),
              ),
            ),
            Row(
              children: [
                Expanded(
                    child: Container(
                  margin: EdgeInsets.only(left: 10.0, right: 15.0),
                  child: Divider(color: Colors.black54, thickness: 2),
                ))
              ],
            ),
            SizedBox(
              height: 10,
            ),
            ListTileTheme(
              child: ListTile(
                tileColor: Colors.white70,
                trailing: Text(
                  '5000',
                  style: TextStyle(fontSize: 30.0, color: Colors.green),
                ),
                title: Text(
                  'Grand Total:',
                  style: TextStyle(fontSize: 30.0),
                ),
              ),
            ),
            ListTileTheme(
              child: ListTile(
                tileColor: Colors.white70,
                title: Text(
                  'View Details',
                  style: TextStyle(
                      fontStyle: FontStyle.italic, color: Colors.blue),
                ),
                onTap: () {
                  Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(builder: (contex) => ViewDetails()),
                  );
                },
              ),
            ),
            SizedBox(
              height: 10,
            ),
            Row(
              children: [
                Expanded(
                    child: Container(
                  margin: EdgeInsets.only(left: 10.0, right: 15.0),
                  child: Divider(color: Colors.black54, thickness: 2),
                ))
              ],
            ),
            ListTileTheme(
              child: ListTile(
                tileColor: Colors.white70,
                trailing: ElevatedButton(
                  onPressed: () {
                    SystemNavigator.pop();
                  },
                  child: Text(
                    'Exit',
                    style: TextStyle(color: Colors.black),
                  ),
                  style: ButtonStyle(
                      backgroundColor:
                          MaterialStateProperty.all<Color>(Colors.orange)),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
