// namespace placeholder
KInherit = {};

/**
 * A function used to extend one class with another
 * 
 * @param {Object} subClass
 * 		The inheriting class, or subclass
 * @param {Object} baseClass
 * 		The class from which to inherit
 */
KInherit.extend = function(subClass, baseClass) {
   function inheritance() {}
   inheritance.prototype = baseClass.prototype;

   subClass.prototype = new inheritance();
   subClass.prototype.constructor = subClass;
   subClass.baseConstructor = baseClass;
   subClass.superClass = baseClass.prototype;
}

