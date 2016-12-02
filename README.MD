# Registration / login system
----------------------
Please note this is not a production ready project. It was created for learning purposes only.

#### MySQL code
```sql
CREATE TABLE `users` (
  `id` varchar(36) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `joined` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```
