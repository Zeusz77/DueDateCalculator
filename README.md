# DueDateCalculator
Trial project for Emarsys

Made by: Zeus

# Dependencies

- PHP 7.4.x
- PHPUnit 9.0.0

# Extras

I used the PHP Dependencie manager Coposer to install PHPUnit as a dependencied, PHPUnit 9.0.0 requires PHP 7.4.x or 7.4.x to work properly.

I try to follow TDD as far as I could, by writing one test case at a time which breaks my function, and then implemented a solution for it, up to the point where I couldn't come up with a test case to break my code.

# The Task

## Due Date Calculator

### The problem
We are looking for a solution that implements a due date calculator in an issue
tracking system. Your task is to implement the CalculateDueDate method:
- Input: Takes the submit date/time and turnaround time.
- Output: Returns the date/time when the issue is resolved.

### Rules
- Working hours are from 9AM to 5PM on every working day, Monday to Friday.
- Holidays should be ignored (e.g. A holiday on a Thursday is considered as a
working day. A working Saturday counts as a non-working day.).
- The turnaround time is defined in working hours (e.g. 2 days equal 16 hours).
If a problem was reported at 2:12PM on Tuesday and the turnaround time is
16 hours, then it is due by 2:12PM on Thursday.
- A problem can only be reported during working hours. (e.g. All submit date
values are set between 9AM to 5PM.)
- Do not use any third-party libraries for date/time calculations (e.g. Moment.js,
Carbon, Joda, etc.) or hidden functionalities of the built-in methods.

### Additional info
- Use your favourite programming language.
- Do not implement the user interface or CLI.
- Do not write a pseudo code. Write a code that you would commit/push to a
repository and which solves the given problem.
- You can submit your solution even if you have not finished it fully.

### Bonus – Not mandatory
- Including automated tests to your solution is a plus.
- Test-driven (TDD) solutions are especially welcome.
- Clean Code (by Robert. C. Martin) makes us happy.