const MongoClient = require('mongodb').MongoClient;
const uri = "mongodb+srv://user:password@cluster.mongodb.net/test?retryWrites=true&w=majority";
const client = new MongoClient(uri, { useNewUrlParser: true });
client.connect(err => {
  const db = client.db("test");

  // Insert a single document
  db.collection("users").insertOne({
    name: "John Doe",
    age: 30
  }, (error, result) => {
    console.log("Document inserted!");
  });

  // Find a single document
  db.collection("users").findOne({ name: "John Doe" }, (error, result) => {
    console.log(result);
  });

  // Update a single document
  db.collection("users").updateOne({ name: "John Doe" }, { $set: { age: 31 } }, (error, result) => {
    console.log("Document updated!");
  });

  // Delete a single document
  db.collection("users").deleteOne({ name: "John Doe" }, (error, result) => {
    console.log("Document deleted!");
  });

  client.close();
});