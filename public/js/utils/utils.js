/**
 * Collection of useful tools
 *
 * by Martin Turjak 2014
 */

/**
 * Capitalize first letter of string (added to String prototype)
 */
String.prototype.firstToUpper = function() {
  return this.charAt(0).toUpperCase() + this.slice(1);
}