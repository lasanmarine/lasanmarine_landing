// Propeller shaft, per the class formula and the k3 table in Site Settings.
// Shared by the Shaft Diameter tool and the Design Brief so they never differ.
//   n = n_e / i          propeller rpm from engine rpm over the gearbox ratio
//   d = k3 · ∛(P / n)    minimum diameter in mm, P in kW

export function propellerRpm(engineRpm, ratio) {
	return engineRpm > 0 && ratio > 0 ? engineRpm / ratio : null;
}

export function shaftDiameter(powerKw, propRpm, k3) {
	return powerKw > 0 && propRpm > 0 && k3 > 0 ? k3 * Math.cbrt(powerKw / propRpm) : null;
}
