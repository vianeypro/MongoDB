const express = require('express');
const MongoClient = require('mongodb').MongoClient;
const bodyParser = require('body-parser');
const app = express();
const port = 3000;
const uri = "mongodb+srv://user:password@cluster.mongodb.net/test?retryWrites=true&w=majority";

app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

MongoClient.connect(uri, { useNewUrlParser: true }, (err, client) => {
  if (err) return console.log(err);
  const db = client.db('test');

  // Add new user
  app.post('/users', (req, res) => {
    const newUser = {
      name: req.body.name,
      age: req.body.age,
      email: req.body.email
    };
    db.collection('users').insertOne(newUser, (error, result) => {
      if (error) return res.send(error);
      res.send(result.ops[0]);
    });
  });

  // Get all users
  app.get('/users', (req, res) => {
    db.collection('users').find().toArray((error, results) => {
      if (error) return res.send(error);
      res.send(results);
    });
  });

  // Get single user
  app.get('/users/:id', (req, res) => {
    db.collection('users').findOne({ _id: req.params.id }, (error, result) => {
      if (error) return res.send(error);
      res.send(result);
    });
  });

  // Update user
  app.put('/users/:id', (req, res) => {
    db.collection('users').updateOne({ _id: req.params.id }, {
      $set: {
        name: req.body.name,
        age: req.body.age,
        email: req.body.email
      }
    }, (error, result) => {
      if (error) return res.send(error);
      res.send(result);
    });
  });

  // Delete user
  app.delete('/users/:id', (req, res) => {
    db.collection('users').deleteOne({ _id: req.params.id }, (error, result) => {
      if (error) return res.send(error);
      res.send(result);
    });
  });

  app.listen(port, () => {
    console.log(`Server running on port ${port}`);
  });
});